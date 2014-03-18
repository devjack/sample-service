<?php

namespace SampleService\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use SampleService\Service\Feature\UserServiceAwareTrait;
use SampleService\Service\Feature\UserFilterServiceAwareTrait;
use SampleService\Form\Feature\FilterFormAwareTrait;

class UserController extends AbstractActionController
{
    use UserServiceAwareTrait;
    use UserFilterServiceAwareTrait;
    use FilterFormAwareTrait;

    /**
    * Filter users action
    */
    public function filterAction()
    {
        $userFilterService = $this->getUserFilterService();

        $urlParams = $this->getEvent()->getRouteMatch()->getParams();
        $userFilterService->configure($urlParams);

        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            /** @var ParametersInterface $post */
            $post = $request->getPost()->toArray();
            $userFilterService->configure($post);
        }

        /** @var FilterForm $form */
        $form = $this->getFilterForm();
        $form->setData($userFilterService->getFilters());

        $userService = $this->getUserService();

        /** @var Paginator $jobPaginator */
        $users = $this->doFilter(
            $userFilterService->getFilters(),
            $userFilterService->getOptions()
        );

        return array(
            'form' => $form,
            'users' => $users,
            'options' => $userFilterService->getOptions(),
        );
    }

    protected function doFilter($filters, $options)
    {

        $userService = $this->getUserService();

        /** @var Paginator $userPaginator */
        $userPaginator = $userService->search(
            array_merge(
                $filters,
                array('options'=>$options)
            )
        );

        return $userPaginator;
    }

}