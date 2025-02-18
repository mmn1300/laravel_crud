<?php

use Illuminate\Support\Facades\DB;


$result = DB::select("SELECT code FROM members");
echo $result;