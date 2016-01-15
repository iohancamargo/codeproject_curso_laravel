<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Validators\ProjectNoteValidator;

class ProjectNoteService
{
	// Classe responsavel pelas regras de negocio!, mandar email, twitter etc
	protected $repository;
	protected $validator;

	public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator)
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

	public function update(array $data,$id,$noteId)
	{
		try{
			$this->validator->with($data)->passesOrFail();
			return $this->repository->update($data, $noteId);	
		
		}catch(ValidatorException $e){
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}	
	}

}