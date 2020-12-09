<?php

declare(strict_types=1);

namespace Cortex\Tenants\Events;

use Cortex\Tenants\Models\Tenant;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TenantDeleted implements ShouldBroadcast
{
    use InteractsWithSockets;
    use Dispatchable;

    /**
     * The name of the queue on which to place the event.
     *
     * @var string
     */
    public $broadcastQueue = 'events';

    /**
     * The model instance passed to this event.
     *
     * @var \Cortex\Tenants\Models\Tenant
     */
    public Tenant $model;

    /**
     * Create a new event instance.
     *
     * @param \Cortex\Tenants\Models\Tenant $tenant
     */
    public function __construct(Tenant $tenant)
    {
        $this->model = $tenant->withoutRelations();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('cortex.tenants.tenants.index'),
            new PrivateChannel("cortex.tenants.tenants.{$this->model->getRouteKey()}"),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'tenant.deleted';
    }
}
