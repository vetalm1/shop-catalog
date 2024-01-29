<?php

namespace App\Policies;


use App\Models\SectionContent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class SectionContentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param SectionContent $sectionContention
     * @return bool
     */
    public function view(User $user, SectionContent $sectionContention): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param SectionContent $sectionContention
     * @return bool
     */
    public function update(User $user, SectionContent $sectionContention): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param SectionContent $sectionContention
     * @return bool
     */
    public function delete(User $user, SectionContent $sectionContention): bool
    {
       return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param SectionContent $sectionContention
     * @return bool
     */
    public function restore(User $user, SectionContent $sectionContention): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param SectionContent $sectionContention
     * @return bool
     */
    public function forceDelete(User $user, SectionContent $sectionContention): bool
    {
        return true;
    }
}
