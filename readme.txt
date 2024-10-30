=== Coin Miner - Coin Hive, and CoinImp monero miner ===
Contributors: ZlaGer
Tags: monero, coinhive, coinimp, cryptocurrency, mining, monetization, wordpress miner, wp mining, bitcoin
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Stable Tag: 1.0.0

This plugin helps you to earn money from visitors on your site by Mining monero.

== Description ==

This plugin helps you to earn money from visitors on your site by using their computing power to mine cryptocurrency named monero or XMR.
The Plugin allows the use of coinimp, and coinhive miners.
It also allows you to check which user is mining how much, and more advanced mining options.
The plugin uses 3rd party services to mine from the user, each "mining" user, will call one of the following files to mine:
https://authedmine.com/lib/authedmine.min.js - coinhive with opt in js miner
https://coinhive.com/lib/coinhive.min.js - coinhive js miner
https://www.freecontent.bid./IbdT.js - coinimp js miner

== Features ==
* **Mine** on Users CPU
* **User Concent ** Ask users before using their computer to mine. This feature isn't blocked by adblocks or antiviruses.
* **Delayed mining**, **start mining faster or slower after X minutes.
* **User Stats** How many users mined today, how many time a user visited and the site, and how much he mined.
* **statistics** for total hashes, hashes running per seconds, total pending monero to payout (only supported by coinhive)
* **Block for Mobile** Option
* **Multiple Miners** try a few miners and decide which one earns you more !


All signup instructions can be found with images under the plugin setting.
signup to CoinImp:

1) Go to https://www.coinimp.com click signup
2) Fill in your email address and create a password.
3) Login to CoinImp
4) Go to Dashboard
5) Add new site
6) Click on "Generate Site Code for Background Mining
7) Copy The Value from the 'ashdjkoiuy76978g76a' (see image) - this is your private Secret Key - go to plugin setting and paste it

Signup to CoinHive:

1) Go to https://CoinHive.com click signup
2) Fill in your email address and create a password.
3) Verify your signup email
4) Login to Coin-Hive
5) go to Setting -> Sites and API Keys
6) Under your site fill in your website name7) Copy your Public Site Key, and your Private Secret Key to the plugin setting

== Statistics ==

all statistics can be found under the Coin Miner admin.
the Dashboard contain summery of the hashes untill today, while the other stats page allows you to see which user mined the most.

== Installation ==

1. Upload the plugin and activate it (alternatively, install through the WP admin console)
2. Go to Settings > Coin-Miner input API keys from CoinImp or CoinHive (detailed instructions can be found under setting page)
3. Save Coin-Miner settings

== Donations ==
**Bitcoin**: 33Mo17qjEig4sqo4uznwBHTS49fzLb8MP6 
**Ethereum**: 0x0f5cEBf617DD13f95614D04863fB1FB15f323568
**PayPal**: ZlaGerr@gmail.com

== Changelog ==

= 0.9.9 =
*Initial Version*

= 0.9.9.1 =
Fix Allow button CoinImp

= 0.9.9.2 =
add opt out and fix opt for all themes

= 1.0.0 = 
update coin-imp miner

== 3rd Party Services == 
The plugin uses 3rd party services to mine from the user. the each "mining" user, will call one of the following files to mine:
https://authedmine.com/lib/authedmine.min.js - coinhive.com js miner with opt in
https://coinhive.com/lib/coinhive.min.js - coinhive.com js miner
https://www.freecontent.bid./IbdT.js - coinimp.com js miner
by the use of coinhive.com miner you agree to terms of service presented in their website:  https://coinhive.com/info/terms-of-service 
you also agree to the privacy agreement that can be found here: https://coinhive.com/info/privacy
by using coinimp.com miner you agree to terms of service presented in their website.
Please note that when you signup with a link to a third party website you enter into a separate contract with that website which is not covered by our terms.

== Screenshots ==

1. Fill the miner details (instructions on main plugin page)
2. see which day was the strongest. or other options from plugin stats page

== Terms and Conditions ==
We are not responsible for any damages to traffic or user expereince by using this plugin and another third party operator (mining company).
It is your legal responsibility to check the legality of mining from users in your jurisdiction.

you can add this passage to your website terms and conditions:

Cryptocurrency Miner
---------------------------

When you visit our website you might be asked to allow cryptocurrency miner to run from your computer, or the website might turn the miner on without asking for user consent.

While this may increase performance for the computer it is most likely it will not result in any noticeable changes in your electricity usage. The miner runs according to your computer performance.

By visiting the website you agree for the <a href="https://eCoin4Dummies.com/CoinMiner">Coin-Miner</a> plugin will be used to mine from your computer.