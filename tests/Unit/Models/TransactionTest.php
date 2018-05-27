<?php

namespace Tests\Unit\Models;

use App\Transaction;
use App\TransactionType;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_transaction_has_type_label_attribute()
    {
        $transaction = factory(Transaction::class)->make(['type' => 'top_up']);
        $this->assertEquals(TransactionType::getById('top_up'), $transaction->type_label);

        $transaction = factory(Transaction::class)->make(['type' => 'cloud_cost']);
        $this->assertEquals(TransactionType::getById('cloud_cost'), $transaction->type_label);
    }

    /** @test */
    public function a_transaction_has_belongs_to_receiver_relation()
    {
        $transaction = factory(Transaction::class)->make();

        $this->assertInstanceOf(User::class, $transaction->receiver);
        $this->assertEquals($transaction->receiver_id, $transaction->receiver->id);
    }

    /** @test */
    public function a_transaction_has_belongs_to_sender_relation()
    {
        $user = $this->createUser();
        $transaction = factory(Transaction::class)->make(['sender_id' => $user->id]);

        $this->assertInstanceOf(User::class, $transaction->sender);
        $this->assertEquals($transaction->sender_id, $transaction->sender->id);
    }
}
