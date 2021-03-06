<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ClientValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientService
{
	// Classe responsavel pelas regras de negocio!, mandar email, twitter etc
	protected $repository;
	protected $validator;

	public function __construct(ClientRepository $repository, ClientValidator $validator)
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
			// dd($e);
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