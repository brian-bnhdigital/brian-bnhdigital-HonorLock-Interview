<?php

namespace App\Http\Requests\Dashboard\Vehicle;

class RetrieveVehiclesRequest extends BaseRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return TRUE;
	}

	public function messages()
	{
		return array('page_id' => 'Required and needs to be a valid integer',);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return array(
			'page_id' => 'required|integer'
		);
	}
}