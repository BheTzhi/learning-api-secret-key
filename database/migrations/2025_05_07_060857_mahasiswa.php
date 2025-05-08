<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurusan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jurusan');
            $table->timestamps();
        });

        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nim')->unique();
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->date('tanggal_lahir');
            $table->string('secret_key')->unique();
            $table->timestamps();
            $table->foreign('jurusan_id')->references('id')->on('jurusan')->onUpdate('cascade')->onDelete('set null');
        });

        Schema::create('kartu_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id')->unique();
            $table->string('nomor_kartu')->unique();
            $table->date('tanggal_terbit');
            $table->timestamps();
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('mata_kuliah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mk');
            $table->string('kode_mk')->unique();
            $table->integer('sks');
            $table->unsignedBigInteger('jurusan_id');
            $table->timestamps();
            $table->foreign('jurusan_id')->references('id')->on('jurusan')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('mahasiswa_mk', function (Blueprint $table) {
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('mk_id');
            $table->integer('semester');
            $table->decimal('nilai_angka', 5, 2);
            $table->char('nilai_huruf', 2);
            $table->timestamps();
            $table->primary(['mahasiswa_id', 'mk_id']);
            $table->foreign('mk_id')->references('id')->on('mata_kuliah')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa_mk');
        Schema::dropIfExists('kartu_mahasiswa');
        Schema::dropIfExists('mahasiswa');
        Schema::dropIfExists('mata_kuliah');
        Schema::dropIfExists('jurusan');
    }
};
