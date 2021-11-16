#!/usr/bin/env bash

dirnow=$(dirname $(realpath $0))
dirroot=$(realpath "$dirnow/..")
printf "\n --- ROOT directory: $dirroot \n"

cd $dirroot/tests/phpunit/tests
groups=$(grep "\@group " * -rh | sed "s/\* \@group //g" | sed -r "s/^\t+//g" | sed -r "s/^\s+//g" | sort -u | sort);

cd $dirroot
> $dirroot/logs/groups.log
> $dirroot/logs/filters.log

for agroup in $groups; do
	printf "\n --- TESTING BY GROUP: $agroup \n"
	phpunit -v --group $agroup --testdox-text $dirroot/logs/$agroup.txt 2>&1 | tee -a $dirroot/logs/groups.log
done

cd $dirroot/logs
for atest in $(grep "\[ " * -h | cut -d" " -f4- | sort -u | sort | cut -d"#" -f1); do
	printf "\n --- TESTING BY FILTER: $atest \n"
	phpunit -v --filter "$atest" --testdox-text $dirroot/logs/$agroup.txt 2>&1 | tee -a $dirroot/logs/filters.log
done

for agroup in $groups; do
	rm -rf $dirroot/logs/$agroup.txt
done
