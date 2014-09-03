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
			$table->integer('from_id'); //源应用ID
			$table->integer('to_id'); //目标应用ID
			$table->string('name', 64); //名称
			$table->string('description'); //描述
			$table->boolean('public')->default(0); //是否公用
			$table->text('data'); //数据{ {'name': 'test', 'type': 'string', 'size': 10} }json数组
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
