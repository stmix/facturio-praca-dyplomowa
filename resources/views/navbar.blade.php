<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

<div class="header">
    <div class="side-nav border-r border-1 bg-zinc-100" style="z-index: 1;">
        <a href="/" class="logo">
            <text class="inlogo">
                Factur.io
            </text>
            <text class="logo-icon">F</text>

        </a>
        <ul class="nav-links">
            <li <?php if($_SESSION['open']=='index') echo 'class="selected"'; ?> ><a href="/main"><i class="material-symbols-outlined">home</i><p>Panel Główny</p></a></li>
            <li <?php if($_SESSION['open']=='history') echo 'class="selected"'; ?> ><a href="/invoices"> <i class="material-symbols-outlined">history</i><p>Historia</p></a></li>
            <li <?php if($_SESSION['open']=='products') echo 'class="selected"'; ?> ><a href="/products"> <i class="material-symbols-outlined">inventory_2</i> <p>Produkty</p></a></li>
            <li <?php if($_SESSION['open']=='clients') echo 'class="selected"'; ?> ><a href="/clients"> <i class="material-symbols-outlined">group</i> <p>Odbiorcy</p></a></li>
            <li <?php if($_SESSION['open']=='invoices') echo 'class="selected"'; ?> ><a href="/invoices/add"> <i class="material-symbols-outlined">request_page</i><p>Nowa faktura</p></a></li>
            <div class="active" style="top:<?php 
            if($_SESSION['open']=='index') {
                echo " 0%;";
            } else if($_SESSION['open']=='history') {
                echo " 20%";
            } else if($_SESSION['open']=='products') {
                echo " 40%";
            } else if($_SESSION['open']=='clients') {
                echo " 60%";
            } else if($_SESSION['open']=='invoices') {
                echo " 80%";
            } else {
                echo "0; display:none;";
            }
            ?>;"></div>
        </ul>
        <div style="height: 200px"></div>
        <ul class="nav-links"><li id="settings_button"><a href="{{ route('settings') }}">
            <i class="material-symbols-outlined">settings</i><p><?php if($_SESSION['open']=='settings') echo '<b>'; ?>Ustawienia<?php if($_SESSION['open']=='settings') echo '</b>'; ?></p></a></li></ul>
        <ul class="nav-links"><li id="logout_button"><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();"> <i class="material-symbols-outlined">logout</i><p>Wyloguj się</p></a></li></ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
    </div>
    
</div>