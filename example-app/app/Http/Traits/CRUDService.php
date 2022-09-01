<?php
	
	namespace App\Http\Traits;
	use Illuminate\Database\Eloquent\Model;
	
	trait CRUDService {
		
		
		/**
		 * @param array $data
		 *
		 * @return Model|false
		 * @throws \Exception
		 */
		public function create(array $data)
		{
			$response = $this->repository->create($data);
			
			return $response
				? $response->fresh()
				: false;
		}
		
		/**
		 * @param Model $model
		 * @param array $data
		 * @return Model|false
		 */
		public function update(Model $model, array $data)
		{
			$response = $this->repository->update($model->id, $data);
			
			return $response
				? $model->fresh()
				: false;
		}

        /**
		 * @param Model $model
		 * @return Model|false
		 */
		public function delete(Model $model)
		{
			$response = $this->repository->delete($model->id);
			
			return $response
				? $model->fresh()
				: false;
		}
	}