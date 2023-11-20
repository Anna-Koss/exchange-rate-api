# Вітаю, шановні

This application receives the bitcoin exchange rate from the https://www.blockchain.com API, 
saves it to its database and provides its own API, allowing you to receive the saved data 
for the user-specified period of time in JSON format. <br>
Currency pairs are currently available:
- BTC / USD <br>
- BTC / EUR <br>
- BTC / GBP <br>

<h3> To run the application</h3>
<ul>
<li> to clone the project write in WSL console: </li>
<pre>           <code> git clone {link} </code></pre> 
<li> run the docker on your computer</li>
<li> to run container write in WSL console:</li> 
 <pre>           <code> docker-compose up -d </code></pre>
<li> then </li>
<pre>           <code> docker-compose exec php bash </code></pre> 
</ul>

<h3> Then inside container: </h3>
<ul>
<li> install the dependencies from composer.json</li>
<pre>           <code> composer install </code></pre> 
<li> run the migrations </li>
<pre>           <code> php bin/console doctrine:migrations:migrate </code></pre> 
<li> Application is ready to work </li>
<li> Application will be available at <code> http://localhost:8080 </code> </li>
</ul>



<h3>How it works</h3>
<li>first of all we need to fill DB with data from external API</li>
<pre>           <code> bin/console app:get-actual-rates </code></pre> 
it is assumed that this command should be run in Cron for full operation <br><br>
<li>to get a list of exchange rates from the API provided by this application
you need to make a request to 
<pre>           <code> http://localhost:8080/api/exchange-rate/{currency}/{datetime-from}/{datetime-till} </code></pre>
possible values {currency}: <br>
<code> - USD <br> </code> 
<code> - EUR <br> </code> 
<code> - GBP <br> </code> 
datetime format <code> Y-m-d H:i:s </code> </li>
<br>
Example: <br>
<code> localhost:8080/api/exchange-rate/USD/2023-11-17 21:31:23/2023-11-19 21:33:23 </code> 
<br>
<br>
<h3>Summary</h3>
<h4>Я не я й кобила не моя</h4>
This application was written on the basis of a test task and for me it was aimed to have  Symfony framework practice. A thousand thanks for the invaluable help of the GPT chat and Big Brother
<a> https://www.linkedin.com/in/oleg-kostyryev-991b5b14a</a>. The application does not pretend to be completed
and has a wide potential for improvement

<br>
<br>
<br>
<br>
<br>
