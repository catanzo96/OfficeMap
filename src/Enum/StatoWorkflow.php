<?php

namespace App\Enum;

enum StatoWorkflow: int
{
    case DISATTIVO = 0;
    case ATTIVO = 1;
    case IN_LAVORAZIONE = 2;
    case APPROVATO = 3;
    case RIFIUTATO = 4;
}