### The-Clean-Architecture-in-PHP-Kristopher-Wilson book project

To run Peridot BDD tests :
`./vendor/bin/peridot specs/` or `./vendor/bin/peridot specs/ --watch`


## create tables
<pre>

`sqlite3 data/database.db`

CREATE TABLE customers(
    id integer primary key,
    name varchar(100) not null,
    email varchar(100) not null
);

CREATE TABLE invoices (
    id integer primary key,
    order_id int references orders(id),
    invoice_date date not null,
    total float not null
);

INSERT INTO customers(name, email) VALUES('Acme Corp', 'ap@acme.com');
INSERT INTO customers(name, email) VALUES('ABC Company', 'invoices@abc.com');
</pre>

