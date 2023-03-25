# local-dev-dashboard

A simple interface to manage your local development projects

## Overview

I created this to help me stay a little more organized and stop creating so many offshoot projects. (Like this one haha)

## Setup

- Put this anywhere within your localhost root.
- Create your projects in the /dev directory.
- Run once and the program will create generic project.json files for each directory.
- Update the project.json file for each accordingly.
- (Optional) Add your styling to the index.php file for your categories like .category-[category_name]{} like the exisitng tool category one

## Notes

- Everything in the project.json file get put into an associative array, so go nuts and add more stuff to it to suit your needs. Reference it in the index.php file as $project['info'][nutty_extra_info_label]
