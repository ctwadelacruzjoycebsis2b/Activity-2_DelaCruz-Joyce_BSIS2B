<?php
$title = 'Errors & Scopes'; include 'includes/header.php';

// ---- Variable scopes ----
$counter = 10;                       // GLOBAL

function show_local() {
    $counter = 1;                    // LOCAL (hiwalay sa global)
    return $counter;
}
function show_global() {
    global $counter;                 // gamit ang global variable
    $counter++;
    return $counter;
}
function show_static() {
    static $calls = 0;               // STATIC: tinatandaan ang value
    $calls++;
    return $calls;
}
?>
<h1>Errors &amp; Variable Scopes</h1>

<div class="card">
<h2>Uri ng PHP errors</h2>
<table>
<tr><th>Uri</th><th>Ibig sabihin</th><th>Tumitigil ba ang script?</th></tr>
<tr><td>Notice</td><td>Maliit na problema, hal. paggamit ng undefined variable</td><td>Hindi</td></tr>
<tr><td>Warning</td><td>Mas seryoso, hal. include ng file na wala</td><td>Hindi</td></tr>
<tr><td>Fatal error</td><td>Hindi na maituloy, hal. tawag sa function na wala</td><td>Oo</td></tr>
<tr><td>Parse error</td><td>Mali ang syntax, hal. kulang na <code>;</code></td><td>Oo (di man lang tatakbo)</td></tr>
</table>
<?php
// Live na Notice/Warning (nakatago ang mismong error, ipinapakita ang mensahe)
set_error_handler(function ($no, $str) use (&$log) {
    $type = [E_WARNING => 'Warning', E_NOTICE => 'Notice', E_USER_NOTICE => 'Notice', E_USER_WARNING => 'Warning', E_DEPRECATED => 'Deprecated'][$no] ?? "Error($no)";
    $log[] = "$type: $str";
    return true;
});
$log = [];
echo $undefined_var;                         // Warning (PHP 8: undefined variable)
$arr = [1, 2]; echo $arr[5];                 // Warning (undefined array key)
echo 10 / 3 . '';                            // OK
restore_error_handler();
try { nonexistent_function(); }              // Fatal -> Error exception sa PHP 8
catch (Error $err) { $log[] = 'Fatal: ' . $err->getMessage(); }
?>
<h3>Live na resulta</h3>
<ul><?php foreach ($log as $l): ?><li><?= e($l) ?></li><?php endforeach; ?></ul>
<p class="muted">Ang Parse error ay hindi maipapakita dito dahil hindi tatakbo ang buong file kapag may syntax error.</p>
</div>

<div class="card">
<h2>Global, Local, at Static scope</h2>
<table>
<tr><th>Scope</th><th>Resulta</th></tr>
<tr><td>Global <code>$counter</code></td><td><?= $counter ?></td></tr>
<tr><td>Local (loob ng function)</td><td><?= show_local() ?></td></tr>
<tr><td>Global gamit ang <code>global</code> (tinawag 2x)</td><td><?= show_global() ?>, <?= show_global() ?></td></tr>
<tr><td>Static (tinawag 3x)</td><td><?= show_static() ?>, <?= show_static() ?>, <?= show_static() ?></td></tr>
</table>
</div>
<?php include 'includes/footer.php'; ?>
