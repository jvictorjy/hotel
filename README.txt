README
======

A aplica��o deve est� na raiz do host para poder funcionar as chamadas JS e CSS.
O banco de dados est� na pasta /docs. Para conectar o banco de dados com a
m�quina local deve-se abrir o arquivo /application/config/application.ini
e mudar os dados de conex�o de [victor : production].


This directory should be used to place project specfic documentation including
but not limited to project notes, generated API/phpdoc documentation, or
manual files generated or hand written.  Ideally, this directory would remain
in your development environment only and should not be deployed with your
application to it's final production location.


Setting Up Your VHOST
=====================

Esse � um exemplo do VHOST para voc� poder setar para iniciar o projeto.
Obs. Deve sempre apontar para a pasta public.

<VirtualHost *:80>
   DocumentRoot "/Users/victorribeiro/Projetos/NewFolder/public"
   ServerName NewFolder.local

   <Directory "/Users/victorribeiro/Projetos/NewFolder/public">
       Options Indexes MultiViews FollowSymLinks
       AllowOverride All
       Order allow,deny
       Allow from all
   </Directory>

</VirtualHost>
