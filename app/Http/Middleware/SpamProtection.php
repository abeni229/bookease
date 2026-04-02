<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SpamProtection
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $config = config('security.spam_protection');

        // Vérifier le champ honeypot (doit être vide)
        $honeypotField = $config['honeypot_field'];
        if ($request->has($honeypotField) && !empty($request->$honeypotField)) {
            abort(403, 'Accès refusé - Activité suspecte détectée');
        }

        // Vérifier le temps minimum entre les requêtes
        $timestampField = $config['timestamp_field'];
        $minTime = $config['min_request_time'];
        $timestamp = $request->input($timestampField);
        if ($timestamp && (time() - $timestamp) < $minTime) {
            abort(429, 'Trop de requêtes. Veuillez patienter.');
        }

        // Vérifier les patterns suspects dans les champs de texte
        $suspiciousPatterns = $config['suspicious_patterns'];
        $fieldsToCheck = ['client_name', 'client_email', 'client_phone', 'notes', 'name', 'description'];

        foreach ($fieldsToCheck as $field) {
            $value = $request->input($field);
            if ($value) {
                foreach ($suspiciousPatterns as $pattern) {
                    if (preg_match($pattern, $value)) {
                        abort(403, 'Contenu non autorisé détecté');
                    }
                }
            }
        }

        return $next($request);
    }
}
