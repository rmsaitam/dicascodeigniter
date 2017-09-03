Usando migrations no CI
<br>
<br>
Como usar:
<br>
1: habilite o migration no arquivo /applications/config/migration.php<br>
$config['migration_enabled'] = TRUE;<br>
2: ainda no mesmo arquivo, sete o migration type como sequencial<br>
$config['migration_type'] = 'sequential';<br>
3: sua versão do migration, inicialmente deve ser 0<br>
$config['migration_version'] = 0;<br>
3: agora dentro de /applications, crie um diretório chamado: migrations.<br>
Esse diretório conterá seus arquivos de migration.<br>
4: crie seus arquivos desta forma: 001_..., 002_... e assim por diante.<br>
note que o nome da classe deve conter Migration_nome_arquivo_sem_os_numeros_iniciais.
<br>
<br>
Agora no browser:
http://base_url/migrate/versao/[num]
<br>
[num] : número da versão de seu migration
<br >
Pronto. Com o exemplo criado, controle a versão de seu banco de dados com essa ótima ferramenta.