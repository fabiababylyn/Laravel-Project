<?php
use Illuminate\Support\Facades\Artisan;
Artisan::command('library:overdue', function () {
    \App\Models\Loan::whereNull('returned_at')->whereDate('due_date','<',today())->update(['status'=>'overdue']);
    $this->info('Overdue records updated.');
})->purpose('Mark unreturned loans past due date as overdue');
