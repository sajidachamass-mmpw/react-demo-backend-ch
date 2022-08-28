<?php


namespace App\Models\Traits;

use App\Models\User\Monita;
use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Traits\HasPermissions;
use function get_class;
trait CanMonita {

    /**
     * A model may have multiple direct permissions.
     */
    public function monitas(): MorphToMany {

        return $this->morphToMany(
            Monita::class,
            'model',
            'model_can_monita',
            'model_id',
            'monita_id'
        );
    }

    /**
     * Remove all current notifications and set the given ones.
     *
     * @param string|array|Permission|Collection $monitas
     *
     * @return $this
     */
    public function syncMonitas( ...$monitas ) {

        $this->monitas()->detach();

        return $this->addMonitaTo( $monitas );
    }

    public function addMonitaTo( ...$monitas ) {

        $monitas = collect( $monitas )
            ->flatten()
            ->map( function ( $monita ) {
                if ( empty( $monita ) ) {
                    return false;
                }

                return $this->getStoredPermission( $monita );
            } )
            ->filter( function ( $monita ) {
                return $monita instanceof Monita;
            } )
            ->map->id
            ->all();

        $model = $this->getModel();

        if ( $model->exists ) {
            $this->monitas()->sync( $monitas, false );

            $model->load( 'monitas' );
        } else {
            $class = get_class( $model );

//            $class::saved(
//                function ($object) use ($monitas, $model) {
//                    static $modelLastFiredOn;
//                    if ($modelLastFiredOn !== null && $modelLastFiredOn === $model) {
//                        return;
//                    }
//                    $object->permissions()->sync($monitas, false);
//                    $object->load('permissions');
//                    $modelLastFiredOn = $object;
//                }
//            );
        }

//        $this->forgetCachedPermissions();

        return $this;
    }

    /**
     * Grant the given permission(s) to a model.
     *
     * @param string|array|Permission|Collection $monitas
     *
     * @return $this
     */
    public function giveMonitaTo( ...$monitas ) {

        $monitas = collect( $monitas )
            ->flatten()
            ->map( function ( $monita ) {
                if ( empty( $monita ) ) {
                    return false;
                }

                return $this->getStoredMonita( $monita );
            } )
            ->filter( function ( $monita ) {
                return $monita instanceof Monita;
            } )
            ->map->id
            ->all();

        $model = $this->getModel();

        if ( $model->exists ) {
            $this->monitas()->sync( $monitas, false );
            $model->load( 'monitas' );
        } else {
            $class = get_class( $model );

            $class::saved(
                function ( $object ) use ( $monitas, $model ) {
                    static $modelLastFiredOn;
                    if ( $modelLastFiredOn !== null && $modelLastFiredOn === $model ) {
                        return;
                    }
                    $object->monitas()->sync( $monitas, false );
                    $object->load( 'monitas' );
                    $modelLastFiredOn = $object;
                }
            );
        }

        return $this;
    }

    protected function getStoredMonita( $monitas ) {
        if ( is_numeric( $monitas ) ) {
            return Monita::find( $monitas );
        }

        if ( is_string( $monitas ) ) {
            return Monita::where( 'name', $monitas )->get();
        }

        if ( is_array( $monitas ) ) {
            return Monita::whereIn( 'name', $monitas )
                         ->get();
        }

        return $monitas;
    }

    protected function convertToMonitaModels( $monitas ): array {
        if ( $monitas instanceof Collection ) {
            $monitas = $monitas->all();
        }

        $monitas = is_array( $monitas ) ? $monitas : [ $monitas ];

        return array_map( function ( $monita ) {
            if ( $monita instanceof Monita ) {
                return $monita;
            }
            return Monita::where( 'name', $monita )->first();
        }, $monitas );

    }

    public function revokeMonitaTo( $monita ) {

        $this->monitas()->detach( $this->getStoredMonita( $monita ) );

        $this->load( 'monitas' );

        return $this;
    }

    public function canMonitaTo( $monita ): bool {

        if ( is_string( $monita ) ) {
            $monita = Monita::where( 'name', $monita )->first();
        }

        if ( is_int( $monita ) ) {
            $monita = Monita::find( $monita );
        }

        return $this->monitas->contains( 'id', $monita->id );
    }

    public function scopeMonita( Builder $query, $monitas ): Builder {

        $monitas = $this->convertToMonitaModels( $monitas );

        $modelsWithMonitas = array_unique( array_reduce( $monitas, function ( $result, $monita ) {
            if ( isset( $monita ) ) {
                return array_merge( $result, $monita->roles->all() );
            } else {
                return [];
            }
        }, [] ) );

        $table = $this->getTable();
            return $query->where(function ($query) use ($monitas, $modelsWithMonitas, $table) {
                $query->whereHas('monitas', function ($query) use ($monitas) {
                    $query->where(function ($query) use ($monitas) {
                        foreach ($monitas as $monita) {
                            if (isset($monita)) {
                                $query->orWhere('monitas.id', $monita->id);
                            }
                        }
                    });
                });
//                if (count($modelsWithMonitas) > 0) {
//                    $query->orWhereHas('roles', function ($query) use ($modelsWithMonitas, $table) {
//                        $query->where(function ($query) use ($modelsWithMonitas, $table) {
//                            foreach ($modelsWithMonitas as $model) {
//                                $query->orWhere($table . '.id', $model->id);
//                            }
//                        });
//                    });
//                }
            });
    }

    public function getTable() {
        $current_class = get_class( $this );

        if ( $current_class == User::class ) {
            return 'users';
        } elseif ( $current_class == Role::class ) {
            return 'roles';
        } else {
            return null;
        }
    }
}
