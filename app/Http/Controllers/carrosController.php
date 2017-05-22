<?php

namespace App\Http\Controllers;

use App\DataTables\carrosDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatecarrosRequest;
use App\Http\Requests\UpdatecarrosRequest;
use App\Repositories\carrosRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class carrosController extends AppBaseController
{
    /** @var  carrosRepository */
    private $carrosRepository;

    public function __construct(carrosRepository $carrosRepo)
    {
        $this->carrosRepository = $carrosRepo;
    }

    /**
     * Display a listing of the carros.
     *
     * @param carrosDataTable $carrosDataTable
     * @return Response
     */
    public function index(carrosDataTable $carrosDataTable)
    {
        return $carrosDataTable->render('carros.index');
    }

    /**
     * Show the form for creating a new carros.
     *
     * @return Response
     */
    public function create()
    {
        return view('carros.create');
    }

    /**
     * Store a newly created carros in storage.
     *
     * @param CreatecarrosRequest $request
     *
     * @return Response
     */
    public function store(CreatecarrosRequest $request)
    {
        $input = $request->all();

        $carros = $this->carrosRepository->create($input);

        Flash::success('Carros saved successfully.');

        return redirect(route('carros.index'));
    }

    /**
     * Display the specified carros.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $carros = $this->carrosRepository->findWithoutFail($id);

        if (empty($carros)) {
            Flash::error('Carros not found');

            return redirect(route('carros.index'));
        }

        return view('carros.show')->with('carros', $carros);
    }

    /**
     * Show the form for editing the specified carros.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $carros = $this->carrosRepository->findWithoutFail($id);

        if (empty($carros)) {
            Flash::error('Carros not found');

            return redirect(route('carros.index'));
        }

        return view('carros.edit')->with('carros', $carros);
    }

    /**
     * Update the specified carros in storage.
     *
     * @param  int              $id
     * @param UpdatecarrosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatecarrosRequest $request)
    {
        $carros = $this->carrosRepository->findWithoutFail($id);

        if (empty($carros)) {
            Flash::error('Carros not found');

            return redirect(route('carros.index'));
        }

        $carros = $this->carrosRepository->update($request->all(), $id);

        Flash::success('Carros updated successfully.');

        return redirect(route('carros.index'));
    }

    /**
     * Remove the specified carros from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $carros = $this->carrosRepository->findWithoutFail($id);

        if (empty($carros)) {
            Flash::error('Carros not found');

            return redirect(route('carros.index'));
        }

        $this->carrosRepository->delete($id);

        Flash::success('Carros deleted successfully.');

        return redirect(route('carros.index'));
    }
}
