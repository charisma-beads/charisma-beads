#!/bin/sh

#cat cot.js > charismabeads.js
#cat awstats_misc_tracker.js >> charismabeads.js
cat pngfix.js > charismabeads.js
cat mootools-core-1.4.5.js >> charismabeads.js
cat mootools-more-1.4.0.1.js >> charismabeads.js
cat dialog.js >> charismabeads.js
cat miniCart.js >> charismabeads.js
#cat pwd.js >> charismabeads.js
cat search.js >> charismabeads.js
cat users.js >> charismabeads.js
cat webshop.js >> charismabeads.js
cat java.js >> charismabeads.js

java -jar ../../yuicompressor.jar -o charismabeads-compressed.js charismabeads.js

