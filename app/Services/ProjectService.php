<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;

use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Filesystem\Filesystem;
// use File;
class ProjectService
{
	// Classe responsavel pelas regras de negocio!, mandar email, twitter etc
	protected $repository;
	protected $validator;

	public function __construct(ProjectRepository $repository, ProjectValidator $validator,Filesystem $fileSystem, Storage $storage)
	{
		$this->repository = $repository;
		$this->validator = $validator;
		$this->fileSystem = $fileSystem;
		$this->storage = $storage;
	}

	public function create(array $data)
	{
		try{

			$this->validator->with($data)->passesOrFail();
			return $this->repository->create($data);
		
		}catch(ValidatorException $e){
			dd($e);
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}
	}

	public function update(array $data,$id)
	{
		try{
			$this->validator->with($data)->passesOrFail();
			return $this->repository->update($data, $id);	
		
		}catch(Exception $e){
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}	
	}

	public function createFile(array $data)
	{
		// $projectId, $extension, $name, $description
		$project = $this->repository->skipPresenter()->find($data['project_id']);
		$projectFile = $project->files()->create($data);

	    $this->storage->put($projectFile->id .".". $data['extension'], $this->fileSystem->get($data['file']));
	}

}