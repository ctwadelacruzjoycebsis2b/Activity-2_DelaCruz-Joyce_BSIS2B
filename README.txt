delacruz.bsis2b.ctwa — Dela Cruz, Joyce (BSIS-2B)

PAANO PATAKBUHIN (XAMPP)
1. Ilagay ang folder na ito sa htdocs.
2. Buksan ang phpMyAdmin > Import > piliin ang schema.sql.
3. I-check ang includes/config.php (DB_USER / DB_PASS).
4. Buksan: http://localhost/delacruz.bsis2b.ctwa/
5. Mag-register, tapos gawing admin sa phpMyAdmin:
   UPDATE users SET role='admin' WHERE email='email_mo@example.com';

LAMAN
- errors_scopes.php  : Notice/Warning/Fatal/Parse + Global/Local/Static
- register.php, login.php, logout.php : Sign In and Register with Database
- admin.php, includes/auth.php : Access Control and Management
- items.php, item_form.php : CRUD Operations
