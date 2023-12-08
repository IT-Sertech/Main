<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main\Db;

use DI\DependencyException;
use DI\NotFoundException;
use Illuminate\Database\Schema\Blueprint;
use Modules\Database\Migration;

class Schema extends Migration {

    /**
     * @return void
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function create(): void {

        if (!$this->schema()->hasTable("page_group")) {
            $this->schema()->create("page_group", function(Blueprint $table){
                $table->engine = "InnoDB";
                $table->increments("id");
                $table->string("name");
                $table->string("title");
                $table->string("description")->nullable();
                $table->string("status");
                $table->string("lang", 5);
                $table->dateTime("created_at");
                $table->dateTime("updated_at");
                $table->index("id");
            });
        }

        if (!$this->schema()->hasTable("page")) {
            $this->schema()->create("page", function(Blueprint $table){
                $table->engine = "InnoDB";
                $table->increments("id");
                $table->integer("page_group_id")->nullable();
                $table->string("name");
                $table->string("title");
                $table->string("description")->nullable();
                $table->longtext("content");
                $table->string("keywords")->nullable();
                $table->string("image")->nullable();
                $table->mediumText("tags")->nullable();
                $table->string("status");
                $table->string("lang", 5);
                $table->integer("landing")->default(0);
                $table->integer("parent_id")->default(0);
                $table->dateTime("created_at");
                $table->dateTime("updated_at");
                $table->foreign('page_group_id')->references('id')->on('page_group');
                $table->index("id");
            });
        }

        if (!$this->schema()->hasTable("settings_group")){
            $this->schema()->create("settings_group", function(Blueprint $table){
                $table->engine = "InnoDB";
                $table->increments("id");
                $table->string("key");
                $table->string("value");
                $table->mediumText("description");
                $table->dateTime("created_at");
                $table->dateTime("updated_at");
            });
        }

        if (!$this->schema()->hasTable("settings")){
            $this->schema()->create("settings", function(Blueprint $table){
                $table->engine = "InnoDB";
                $table->increments("id");
                $table->integer("settings_group_id");
                $table->string("key");
                $table->string("value");
                $table->mediumText("description");
                $table->dateTime("created_at");
                $table->dateTime("updated_at");
                $table->foreign('settings_group_id')->references('id')->on('settings_group');
            });
        }

        if (!$this->schema()->hasTable("landing_page")){
            $this->schema()->create("landing_page", function(Blueprint $table){
                $table->engine = "InnoDB";
                $table->increments("id");
                $table->string("path");
                $table->string("title");
                $table->string("description")->nullable();
                $table->longtext("content");
                $table->string("keywords")->nullable();
                $table->string("image")->nullable();
                $table->mediumText("tags")->nullable();
                $table->string("status");
                $table->string("lang", 5);
                $table->dateTime("created_at");
                $table->dateTime("updated_at");
            });
        }

        if (!$this->schema()->hasTable('actions')) {
            $this->schema()->create('actions', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('title');
                $table->longtext('description')->nullable();
                $table->longtext('annotation');
                $table->longtext('page_url')->nullable();
                $table->longtext('product_url')->nullable();
                $table->longtext('video_url')->nullable();
                $table->longtext('image')->nullable();
                $table->integer('status')->nullable();
                $table->dateTime('created_at');
                $table->dateTime('updated_at');
                $table->index('id');
            });
        }
    }

    /**
     * @return void
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function update(): void {
        if ($this->schema()->hasTable("page")) {
            $this->schema()->whenTableDoesntHaveColumn("page", "test", function(Blueprint $table){
                $table->string("test")->nullable(true)->after("content");
            });
        }
    }

    /**
     * @return void
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function delete(): void {
        if ($this->schema()->hasTable("page")) {
            $this->schema()->drop("page");
        }
    }

}
