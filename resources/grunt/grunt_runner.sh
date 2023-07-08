#!/bin/bash

# This script will run the set of commands used for grunt
# Created on: 2023-04-19

# It will concat and minify the CSS files
function run_css()
{
    sleep 1
    grunt concat:css
    sleep 1
    grunt cssmin:css
}

# It will minify and obfuscate the javascript files
function run_js()
{
    # Copy is optional
    # grunt copy
    grunt concat:js
    sleep 1
    grunt uglify
    sleep 1
    grunt obfuscator
}

function check_grunt_file_exists()
{
    if [[ ! -f './Gruntfile.js' ]]; then
        echo -e "[-] Grunt file doesn't exist!\n"
        exit -1
    fi
}

function check_args()
{
    if [[ $1 != '-t' ]]
    then
        echo -e "[-] Usage: $0 -t [TASK_NAME]\n"
        echo -e "[-] Available tasks: [css, js]\n"
        exit -1
    elif [[ $2 == '' ]]
    then
        echo -e "[-] Usage: $0 -t [TASK_NAME]\n"
        echo -e "[-] Available tasks: [css, js]\n"
        exit -1
    fi
}

function main()
{
    echo -e "\tGrunt runner\n"
    check_grunt_file_exists
    check_args $*
    while getopts t: flag
    do
        case "${flag}" in
            t) task=${OPTARG};;
        esac

        if [[ $task == 'js' || $task == 'css' ]]
        then
            if [[ $task == 'js' ]]; then
                echo -e "-> Running grunt tasks for $task\n";
                run_js
                if [[ $? == 0 ]]; then
                    echo -e "-> Tasks for $task done successfully\n"
                fi
            elif [[ $task == 'css' ]]; then
                echo -e "-> Running grunt tasks for $task\n";
                run_css
                if [[ $? == 0 ]]; then
                    echo -e "-> Tasks for $task done successfully\n"
                fi
            fi
        else
            echo -e "[-] Provide valid task name!\n"
            echo -e "[-] Usage: $0 -t [TASK_NAME]\n"
            echo -e "[-] Available tasks: [css, js]\n"
            exit -1;
        fi
    done
}

main $*