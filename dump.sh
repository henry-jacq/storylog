#!/bin/bash

# Dump contents of all files from the current directory,
# excluding node_modules, __pycache__, .git, venv directories
# and excluding *-lock.json, .DS_Store files.

find . \
  \( -type d \( -name "node_modules" -o -name "__pycache__" -o -name ".git" -o -name "venv" -o -name "frontend" \) -prune \) \
  -o -type f \
  ! -name "*-lock.json" \
  ! -name ".DS_Store" \
  -print \
| sort \
| while read -r file; do
    echo -e "\n"
    echo "FILE: $file"
    echo "========================================"
    echo
    cat "$file"
    echo
    echo
  done
