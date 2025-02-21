<?php

namespace OpenAdmin\Admin\Controllers;

use OpenAdmin\Admin\Grid\Actions\Restore;
use OpenAdmin\Admin\Grid\Tools\BatchRestore;

trait HasRecycleBin
{
    public function __construct()
    {
        // register hooks

        $this->registerHook('alterGrid', function ($controller, $grid) {
            $grid->filter(function ($filter) {
                $filter->scope('trashed', __('admin.recyclebin'))->onlyTrashed();
            });

            $grid->actions(function ($actions) {
                if (request('_scope_') == 'trashed') {
                    $actions->add(new Restore());
                    $actions->disableView();
                    $actions->disableEdit();
                }

                return $actions;
            });

            $grid->batchActions(function ($batch) {
                if (request('_scope_') == 'trashed') {
                    $batch->add(new BatchRestore());
                }
            });

            return $grid;
        });
    }
}
