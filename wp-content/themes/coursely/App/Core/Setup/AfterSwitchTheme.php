<?php

namespace coursely\App\Core\Setup;

use coursely\App\Core\DB\InvoiceTable;
use coursely\App\Core\DB\LessonsProgressTable;
use coursely\App\Core\DB\SubscriptionTable;

class AfterSwitchTheme
{
    public function __construct(){
        add_action('after_switch_theme', [$this, 'run']);
    }
    public function run(): void
    {

        $invoiceTable  = new InvoiceTable();
        $invoiceTable->create();
        $subscriptionTable = new SubscriptionTable();
        $subscriptionTable->create();
        $lessonsProgressTable = new LessonsProgressTable();
        $lessonsProgressTable->create();
    }
}