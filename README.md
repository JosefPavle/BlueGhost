# BlueGhost

## Požadavky :
 - https://getcomposer.org/
 - https://nodejs.org/en/
 - Nahraditelné  :
   - https://git-scm.com/  (jiný verzovací sytsém)
   - https://www.wampserver.com/en/  (jiný lokální server)

## Postup
1.  git clone https://github.com/JosefPavle/BlueGhost.git (nebo stahnout .zip) do vyzadované složky
  
2.  zkopírujte složku .env a kopii prejmenujte na .env.local a změnte si databazové údaje (DATABASE_URL="mysql://uzivatelskeJmeno:hesloDatabaze@127.0.0.1:3306/nazevDatabaze?serverVersion=8&charset=utf8mb4")
  
3.  v konzoli běžte do složky kam jste nainstalovali program a napište:
  - php bin/console doctrine:database:create
  - php bin/console doctrine:migrations:migrate
  - composer install
  - npm install --global yarn
  - yarn install
  - yarn encore dev
 
4. udělejte VirtualHost
  - spustite wamp
  - kliknete na wamp ikonu v pravo dole
  - vyberete Your VirtualHosts
  - vyberete VirtualHost Management
