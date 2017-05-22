<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatecarrosAPIRequest;
use App\Http\Requests\API\UpdatecarrosAPIRequest;
use App\Models\carros;
use App\Repositories\carrosRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class carrosController
 * @package App\Http\Controllers\API
 */

class carrosAPIController extends AppBaseController
{
    /** @var  carrosRepository */
    private $carrosRepository;

    public function __construct(carrosRepository $carrosRepo)
    {
        $this->carrosRepository = $carrosRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/carros",
     *      summary="Get a listing of the carros.",
     *      tags={"carros"},
     *      description="Get all carros",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/carros")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->carrosRepository->pushCriteria(new RequestCriteria($request));
        $this->carrosRepository->pushCriteria(new LimitOffsetCriteria($request));
        $carros = $this->carrosRepository->all();

        return $this->sendResponse($carros->toArray(), 'Carros retrieved successfully');
    }

    /**
     * @param CreatecarrosAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/carros",
     *      summary="Store a newly created carros in storage",
     *      tags={"carros"},
     *      description="Store carros",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="carros that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/carros")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/carros"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatecarrosAPIRequest $request)
    {
        $input = $request->all();

        $carros = $this->carrosRepository->create($input);

        return $this->sendResponse($carros->toArray(), 'Carros saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/carros/{id}",
     *      summary="Display the specified carros",
     *      tags={"carros"},
     *      description="Get carros",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of carros",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/carros"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var carros $carros */
        $carros = $this->carrosRepository->findWithoutFail($id);

        if (empty($carros)) {
            return $this->sendError('Carros not found');
        }

        return $this->sendResponse($carros->toArray(), 'Carros retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatecarrosAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/carros/{id}",
     *      summary="Update the specified carros in storage",
     *      tags={"carros"},
     *      description="Update carros",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of carros",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="carros that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/carros")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/carros"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatecarrosAPIRequest $request)
    {
        $input = $request->all();

        /** @var carros $carros */
        $carros = $this->carrosRepository->findWithoutFail($id);

        if (empty($carros)) {
            return $this->sendError('Carros not found');
        }

        $carros = $this->carrosRepository->update($input, $id);

        return $this->sendResponse($carros->toArray(), 'carros updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/carros/{id}",
     *      summary="Remove the specified carros from storage",
     *      tags={"carros"},
     *      description="Delete carros",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of carros",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var carros $carros */
        $carros = $this->carrosRepository->findWithoutFail($id);

        if (empty($carros)) {
            return $this->sendError('Carros not found');
        }

        $carros->delete();

        return $this->sendResponse($id, 'Carros deleted successfully');
    }
}
