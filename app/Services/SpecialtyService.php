<?php

namespace App\Services;

use App\Models\Specialty;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


class SpecialtyService
{
    public function list(string $lang = 'en')
    {
        return Specialty::latest()
            ->get()
            ->map(function ($specialty) use ($lang) {
                $specialty->name = $specialty->getTranslation('name', $lang);
                if ($specialty->description) {
                    $specialty->description = $specialty->getTranslation('description', $lang);
                }
                return $specialty;
            });
    }


    public function create(array $data): Specialty
    {
        Gate::authorize('manage-specialties');

        return DB::transaction(function () use ($data) {
            $specialty = new Specialty();
            $specialty->setTranslations('name', $data['name']);
            if (isset($data['description'])) {
                $specialty->setTranslations('description', $data['description']);
            }
            $specialty->save();

            return $specialty;
        });
    }

    public function update(Specialty $specialty, array $data): Specialty
    {
        Gate::authorize('manage-specialties');

        return DB::transaction(function () use ($specialty, $data) {
            if (isset($data['name'])) {
                $specialty->setTranslations('name', $data['name']);
            }

            if (isset($data['description'])) {
                $specialty->setTranslations('description', $data['description']);
            }

            $specialty->save();
            return $specialty;
        });
    }

    public function delete(Specialty $specialty): void
    {
        Gate::authorize('manage-specialties');

        if ($specialty->doctors()->exists()) {
            throw new AccessDeniedHttpException(
                'Cannot delete specialty linked to doctors.'
            );
        }

        $specialty->delete();
    }
}
