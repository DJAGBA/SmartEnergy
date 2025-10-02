<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twilio\Rest\Client;

class SendTestSms extends Command
{
    protected $signature = 'sms:test';
    protected $description = 'Envoie un SMS de test via Twilio';

    public function handle()
    {
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        try {
            $twilio->messages->create(
                '+22893499828', // ← ton numéro togolais vérifié
                [
                    'from' => env('TWILIO_NUMBER'),
                    'body' => 'Bonjour Véronique, ceci est un test SMS depuis Laravel !'
                ]
            );

            $this->info('✅ SMS envoyé avec succès !');
        } catch (\Exception $e) {
            $this->error('❌ Erreur : ' . $e->getMessage());
        }
    }
}