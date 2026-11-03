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

    public function created(Agenda $agenda): void
    {
        $this->agendaRepository->clearCache();
    }

    public function updated(Agenda $agenda): void
    {
        $this->agendaRepository->clearCache();
    }

    public function deleted(Agenda $agenda): void
    {
        $this->agendaRepository->clearCache();
    }
}
