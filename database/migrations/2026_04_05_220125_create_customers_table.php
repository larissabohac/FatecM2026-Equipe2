<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {

            $table->id();

            // relação com usuário (login)
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // tipo de pessoa
            $table->enum('type', ['fisica', 'juridica']);

            // dados principais
            $table->string('name');

            $table->string('cpf')->nullable();
            $table->string('cnpj')->nullable();

            // endereço
            $table->string('cep')->nullable();
            $table->string('address')->nullable();
            $table->string('number')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();

            // contato
            $table->string('phone')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};