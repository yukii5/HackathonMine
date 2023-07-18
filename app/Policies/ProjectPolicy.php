<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * 管理者
     * プロジェクトメンバー created_user_id
     * プロジェクト作成者
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Project $project)
    {
        return $user->admin 
            || $project->users->contains($user)
            || $project->created_user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * 管理者
     * プロジェクト責任者
     * プロジェクト作成者
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Project $project)
    {
        return $user->admin 
        || $project->responsible_person_id === $user->id
        || $project->created_user_id === $user->id;
    }

    /**
     * 管理者
     * プロジェクト責任者　responsible_person_id
     * プロジェクト作成者
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Project $project)
    {
        return $user->admin 
        || $project->responsible_person_id === $user->id
        || $project->created_user_id === $user->id;
    }

    /**
     * 管理者
     * プロジェクト責任者　responsible_person_id
     * プロジェクト作成者
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function status(User $user, Project $project)
    {
        return $user->admin 
        || $project->responsible_person_id === $user->id
        || $project->created_user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Project $project)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Project $project)
    {
        //
    }
}
