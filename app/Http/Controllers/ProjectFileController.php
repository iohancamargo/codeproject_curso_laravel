<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;

use CodeProject\Entities\Client;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;

use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Filesystem\Filesystem;
class ProjectFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $repository;

    public function __construct(ProjectRepository $repository, ProjectService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }   

    public function index()
    {
        return $this->repository->findwhere(['owner_id'=>\Authorizer::getResourceOwnerId()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //formulario
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');

        $extension = $file->getClientOriginalExtension();

        $data['file'] = $file;
        $data['extension'] = $extension;
        $data['name'] = $request->name;
        $data['project_id'] = $request->project_id;
        $data['description'] = $request->description;

        $this->service->createFile($data);
        // echo $request->name;die;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($this->checkProjectPermissions($id) == false){
            return ['error' => 'Acesso não permitido'];
        } 
        return $this->repository->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $this->repository->find($id);
        if($this->checkProjectOwner($id) == false){
            return ['error' => 'Acesso não permitido'];
        } 
        $this->service->update($request->all(), $id);
        return $this->repository->find($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->checkProjectOwner($id) == false){
            return ['error' => 'Acesso não permitido'];
        } 
        $this->repository->find($id)->delete();
    }


    private function checkProjectOwner($projectId)
    {
        $userId = \Authorizer::getResourceOwnerId();
        // $projectId = $request->project;

        if($this->repository->isOwner($projectId, $userId)){
            return ['error'=>'Acesso não permitido'];
        }
    }

    private function checkProjectMember($projectId)
    {
        $userId = \Authorizer::getResourceOwnerId();
        // $projectId = $request->project;
        return $this->repository->hasMember($projectId, $userId);
    }

    private function checkProjectPermissions($projectId)
    {
        if ( ($this->checkProjectOwner($projectId)) or ($this->checkProjectMember($projectId)))
        {
            return true;
        }else{
            return false;
        }
    }

}
