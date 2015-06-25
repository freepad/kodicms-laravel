<?php namespace KodiCMS\Cron\Http\Controllers;

use Assets;
use KodiCMS\Cron\Repository\CronRepository;
use KodiCMS\CMS\Http\Controllers\System\BackendController;

class CronController extends BackendController
{
	/**
	 * @var string
	 */
	public $moduleNamespace = 'cron::';

	public function getIndex(CronRepository $repository)
	{
		$jobs = $repository->paginate();
		$this->setContent('cron.list', compact('jobs'));
	}

	public function getCreate(CronRepository $repository)
	{
		$this->setTitle(trans('cron::core.title.cron.create'));
		Assets::package('cron');

		$job = $repository->instance();
		$action = 'backend.cron.create.post';

		$this->templateScripts['JOB'] = $job->toArray();

		$this->setContent('cron.form', compact('job', 'action'));
	}

	public function postCreate(CronRepository $repository)
	{
		$data = $this->request->all();
		$repository->validateOnCreate($data);
		$job = $repository->create($data);

		return $this->smartRedirect([$job])
			->with('success', trans('cron::core.messages.created', ['title' => $job->name]));
	}

	public function getEdit(CronRepository $repository, $id)
	{
		$job = $repository->findOrFail($id);

		Assets::package('cron');
		$this->templateScripts['JOB'] = $job->toArray();

		$this->setTitle(trans('cron::core.title.cron.edit', [
			'title' => $job->name
		]));
		$action = 'backend.cron.edit.post';

		$this->setContent('cron.form', compact('job', 'action'));
	}

	public function postEdit(CronRepository $repository, $id)
	{
		$data = $this->request->all();

		$repository->validateOnUpdate($data);

		$job = $repository->update($id, $data);

		return $this->smartRedirect([$job])
			->with('success', trans('cron::core.messages.updated', ['title' => $job->name]));
	}

	public function postDelete(CronRepository $repository, $id)
	{
		$job = $repository->delete($id);
		return $this->smartRedirect()
			->with('success', trans('cron::core.messages.deleted', ['title' => $job->name]));
	}

	public function getRun(CronRepository $repository, $id)
	{
		$job = $repository->runJob($id);
		return redirect(route('backend.cron.edit', $job))
			->with('success', trans('cron::core.messages.runned', ['title' => $job->name]));
	}

}