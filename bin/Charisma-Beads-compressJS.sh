#!/bin/sh

#cat ../public/js/cot.js > ../public/js/charismabeads.js
#cat ../public/js/awstats_misc_tracker.js >> ../public/js/charismabeads.js
cat ../public/js/pngfix.js > ../public/js/charismabeads.js
cat ../public/js/mootools-core-1.4.5.js >> ../public/js/charismabeads.js
cat ../public/js/mootools-more-1.4.0.1.js >> ../public/js/charismabeads.js
#cat ../public/js/dialog.js >> ../public/js/charismabeads.js
#cat ../public/js/miniCart.js >> ../public/js/charismabeads.js
#cat ../public/js/pwd.js >> ../public/js/charismabeads.js
cat ../public/js/search.js >> ../public/js/charismabeads.js
cat ../public/js/users.js >> ../public/js/charismabeads.js
cat ../public/js/webshop.js >> ../public/js/charismabeads.js
cat ../public/js/java.js >> ../public/js/charismabeads.js

java -jar ./yuicompressor-2.4.2.jar -o ../public/js/charismabeads-compressed.js ../public/js/charismabeads.js

