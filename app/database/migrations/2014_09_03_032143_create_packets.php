<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackets extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('packets', function($table)
		{
			$table->increments('id');
			$table->integer('from_id'); //ԴӦ��ID
			$table->integer('to_id'); //Ŀ��Ӧ��ID
			$table->string('name', 64); //����
			$table->string('description'); //����
			$table->boolean('public')->default(0); //�Ƿ���
			$table->text('data'); //����{ {'name': 'test', 'type': 'string', 'size': 10} }json����
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('packets');
	}

}
