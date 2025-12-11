# WIP

# Table of Contents

- [Introduction](#introduction)
- [Installation](#installation)
  - [Composer](#composer)

# Introduction

Package providing Filament UI to task management system.

# Installation

Package uses other packages under the hood

## Composer

### 1. Add repository sources into `composer.json` file in application root directory

```json
"repositories": [
        ...,
        {
            "type": "vcs",
            "url": "git@github.com:dp-bratislava/pkg-task-ms.git"
        },        
        {
            "type": "vcs",
            "url": "git@github.com:dp-bratislava/pkg-task-ms-ui.git"
        },        
        ...,
]
```

### 2. Install composer repositories

```bash
# install package
composer require dpb/pkg-task-ms-ui
```