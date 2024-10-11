<?php

namespace App\Providers;

use App\Models\Competencies;
use App\Models\Candidates;
use App\Models\Languages;
use App\Models\Positions;
use App\Models\Training;
use App\Policies\CompetenciesPolicy;
use App\Policies\LanguagesPolicy;
use App\Policies\TrainingPolicy;
use App\Policies\PositionsPolicy;
use App\Policies\CandidatesPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Competencies::class, CompetenciesPolicy::class);
        Gate::policy(Languages::class, LanguagesPolicy::class);
        Gate::policy(Training::class, TrainingPolicy::class);
        Gate::policy(Positions::class, PositionsPolicy::class);
        Gate::policy(Candidates::class, CandidatesPolicy::class);
    }
}
