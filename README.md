# binary-tree

`documents.json` - file with source data


Create index `php create-index.php`
option `-f` - field name, required 

example: 

```
php create-index.php -fname
```
Executing `php create-index.php -fname` will create an index for the name field and write it to the `index_name.json` file.

Search document by field `php search.php`

options:

 `-f` - field name, required
 
 `-v` - field value

example: 

```
php search.php -fname -vJon
```
