#!/usr/bin/env bash

dirnow=$(dirname $(realpath $0))
dirroot=$(realpath "$dirnow/..")
printf "\n --- ROOT directory: $dirroot \n"

cd $dirroot/tests/phpunit


sfiles=$(grep -P "^\tfunction set_up\(" -r --include \*.php | \
grep -iv "function set_up_" | cut -d":" -f1 | sort -u | sort)

tfiles=$(grep -P "^\tfunction tear_down\(" -r --include \*.php | \
grep -iv "function tear_down_" | cut -d":" -f1 | sort -u | sort)

ttfiles=$(grep -P "^\tfunction test_" -r --include \*.php | \
cut -d":" -f1 | sort -u | sort)


allfiles=$(printf "$tfiles\n$sfiles\n$ttfiles" | sort -u | sort)


for afile in $allfiles; do
	afile=$(realpath $afile)
	printf "\n --- $afile"
	chmod 644 "$afile" && chown $USER "$afile"

	sed -i -r 's/^\tfunction set_up\(/\tpublic function set_up\(/g' "$afile"
	sed -i -r 's/^\tfunction tear_down\(/\tpublic function tear_down\(/g' "$afile"
	sed -i -r 's/^\tfunction test_/\tpublic function test_/g' "$afile"
done

grep -P "^\tfunction set_up\(" -r --include \*.php
grep -P "^\tfunction tear_down\(" -r --include \*.php
grep -P "^\tfunction test_" -r --include \*.php

printf "\n\n"
