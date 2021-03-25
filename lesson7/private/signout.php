<?php
session_start();
// сбрасываем сессию
session_destroy();
// переадрессация
header('Location: ../');
