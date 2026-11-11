<?php
namespace Database\Seeders;
use App\Models\User; use App\Models\Book; use Illuminate\Database\Seeder; use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder {
 public function run(): void {
  User::updateOrCreate(['email'=>'admin@library.test'],['name'=>'System Administrator','password'=>Hash::make('Admin123!'),'role'=>'admin']);
  User::updateOrCreate(['email'=>'librarian@library.test'],['name'=>'Library Staff','password'=>Hash::make('Librarian123!'),'role'=>'librarian']);
  User::updateOrCreate(['email'=>'student@library.test'],['name'=>'Sample Student','password'=>Hash::make('Student123!'),'role'=>'student','student_number'=>'2026-0001']);
  $samples=[
   ['Introduction to Computing','Peter Norton','9780000000001','Information Technology','Pearson',2022,5],
   ['Database System Concepts','Abraham Silberschatz','9780000000002','Information Technology','McGraw-Hill',2020,4],
   ['Clean Code','Robert C. Martin','9780000000003','Programming','Prentice Hall',2008,3],
   ['The Great Gatsby','F. Scott Fitzgerald','9780000000004','Literature','Scribner',1925,2],
   ['Fundamentals of Networking','James Kurose','9780000000005','Networking','Pearson',2021,4],
   ['Learning PHP and MySQL','Michele Davis','9780000000006','Programming','O Reilly',2020,3]
  ];
  foreach($samples as $b) Book::firstOrCreate(['isbn'=>$b[2]],['title'=>$b[0],'author'=>$b[1],'category'=>$b[3],'publisher'=>$b[4],'publication_year'=>$b[5],'total_copies'=>$b[6],'available_copies'=>$b[6]]);
 }
}
