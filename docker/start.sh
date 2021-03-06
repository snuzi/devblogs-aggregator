#!/bin/bash

printenv | sed 's/^\(.*\)\=\(.*\)$/export \1\="\2"/g' > /root/project-env.sh
chmod +x /root/project-env.sh
cron && tail -f /var/log/cron.log
