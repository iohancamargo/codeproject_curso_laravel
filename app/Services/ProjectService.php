<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;

class ProjectService
{
	// Classe responsavel pelas regras de negocio!, mandar email, twitter etc
	protected $repository;
	protected $validator;

	public function __construct(ProjectRepository $repository, ProjectValidator $validator)
	{
		$this->repository = $repository;
		$this->validator = $validator;
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

}