<?php

namespace App\Observers;

use App\Models\Agenda;
use App\Repositories\AgendaRepository;

class AgendaObserver
{
    protected AgendaRepository $agendaRepository;

    public function __construct()
    {
        $this->agendaRepository = new AgendaRepository();
    }

    /**
     * Handle the Agenda "created" event.
     */
    public function created(Agenda $agenda): void
    {
        $this->agendaRepository->clearCache();
    }

    /**
     * Handle the Agenda "updated" event.
     */
    public function updated(Agenda $agenda): void
    {
        $this->agendaRepository->clearCache();
    }

    /**
     * Handle the Agenda "deleted" event.
     */
    public function deleted(Agenda $agenda): void
    {
        $this->agendaRepository->clearCache();
    }
}
