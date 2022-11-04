<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->dropView());
        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement($this->dropView());
    }

    protected function createView(): string
    {
        return <<<SQL
			CREATE VIEW `view_information_invoices` as
			SELECT
				1 as group_no,
				inhouses.id,
				inhouses.id as inhouse_id,
				'Room' as description,
				r.room_no as reference,
				inhouses.room_rate as price,
				inhouses.session_hours as qty,
				inhouses.room_rate * inhouses.session_hours as amount
			from
				inhouses
			left join rooms r on r.id = inhouses.room_id
			left join room_types rt on rt.id = r.room_type_id
			union
			SELECT
				2 as group_no,
				od.id,
				inhouse_id as inhouse_id,
				'Food' as description,
				food.food_name as reference,
				od.price as price,
				od.qty as qty,
				od.price * od.qty as amount
			from
				orders
			left join order_details od on od.order_id = orders.id
			left join food on food.id = od.food_id
			union
			SELECT
				3 as group_no,
				inhouse_services.id,
				inhouse_id as inhouse_id,
				'Service Staff' as description,
				ss.nick_name as reference,
				service_staff_rate as price,
				inhouse_services.session_hours as qty,
				inhouse_services.session_hours * service_staff_rate as amount
			from inhouse_services
			left join service_staff ss on ss.id = inhouse_services.service_staff_id
			union
			SELECT
				1 as group_no,
				income_transactions.id,
				inhouse_id as inhouse_id,
				'Adjustment' as description,
				concat(transactions.transaction_name, ' - ', remark) as reference,
			case
				when transactions.isAddition = false then amount * -1
				else amount
			end as price,
			1 as qty,
			case
				when transactions.isAddition = false then amount * -1
				else amount
			end as amount
			from income_transactions
			left join transactions on transactions.id = income_transactions.transaction_id
		SQL;
    }

    protected function dropView(): string
    {
        return <<<SQL
			DROP VIEW IF EXISTS `view_information_invoices`;
		SQL;
    }
};
