<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use App\Models\Assembly\Assembly;
use App\Models\Assignment\Assignment;
use Illuminate\Database\Eloquent\Model;
use App\Models\Establishment\Establishment;
use App\Models\Assembly\AssemblyHasProfile;
use App\Models\Assignment\AssignmentHasProfile;
use App\Models\Establishment\EstablishmentHasProfile;

final class EstablishmentRelationshipsSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $establishments = Establishment::has('likes')->get(); // FIXME
            foreach ($establishments as $establishment) {
                $randomeEtablishments = rand(1, 7);
                match ((int) $randomeEtablishments) {
                    1 => $this->establishables($establishment, new Assembly),
                    2 => $this->establishables($establishment, new AssemblyHasProfile),
                    3 => $this->establishables($establishment, new Assignment),
                    4 => $this->establishables($establishment, new AssignmentHasProfile),
                    5 => $this->establishables($establishment, new Establishment),
                    6 => $this->establishables($establishment, new EstablishmentHasProfile),
                    7 => $this->establishables($establishment, new User),
                };
            }
        } catch (\Throwable $e) {
        }
        dump(__METHOD__ . ' [success]');
    }

    private function establishables(Establishment $establishment, Model $model): void
    {
        $pivots = ['has_profile' => 0];
        for ($i = 0; $i < 10; $i++) {
            try {
                $models = $model::where('uuid', '!=', $establishment->uuid)->get();
                if ($models->isNotEmpty()) {
                    $establishable = $models->random();
                    if (
                        $establishment->establishables($model)->get()->isEmpty()
                        ||
                        !$establishment->establishables($model)->get()->contains($establishable)
                    ) {
                        $establishment->establishables($model)->attach($establishable, $pivots);
                    }
                }
            } catch (\Throwable  $e) {
            }
        }
    }
}
