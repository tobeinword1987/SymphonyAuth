<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Users_hobbies;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;

//use AppBundle\Entity\Task;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @Route("/auth", name="authpage")
     */
    
    public function indexAction(Request $request)
    {
        $user = new User();

        if($request->get('login') != ''){
            $user->setLogin($request->get('login').'*');
        }

        $user->setPassword($request->get('password'));
        
        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        $user->setLogin($request->get('login'));

        if ((($request->get('submit') == 'Sign')||(empty($request->get('submit')))) && count($errors)>0) {

            return $this->render('auth/welcome.html.twig', array(
                'errors' => $errors,
                'request' => $request,
                'user_error' => null
            ));
        } else {
            $login = $request->get('login');
            $password = $request->get('password');

            //Выведем данные пользователю, чтобы он мог их редактировать
            $repository = $this->getDoctrine()->getRepository('AppBundle:User');

            $user = $repository->findOneBy(
                array('login' => $login, 'password' => $password)
            );

            if(!empty($user)){

                $hobbies = $this->getHobbies($user);

                //Отправим пользователя на форму с редактированием его данных
                return $this->render('auth/user.html.twig', array(
                    'user' => $user,
                    'errors' => $errors,
                    'user_interests' => $hobbies
                ));
            } else if ($request->get('submit') == 'Sign'){
                //Отправим пользователя на форму ввода логина и пароля
                return $this->render('auth/welcome.html.twig', array(
                    'errors' => null,
                    'request' => $request,
                    'user_error' => 'Wrong password or login'
                ));

            } else {
                //отправим пользователя на страницу регистрации
                return $this->render('auth/registration.html.twig', array(
                    'user' => $user,
                    'errors' => $errors,
                    'user_error' => null,
                    'request' => $request,
                ));
            }

        }
    }

    /**
     * @Route("/user/{id}", name="add user")
     */

    public function userAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository('AppBundle:User');

        $user = $repository->findOneById($id);

//        $hobbies = $this->getHobbies($user);

        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        if (!$user) {
            throw $this->createNotFoundException(
                'No product found for id '.$user
            );
        }

        $user->setFirstName($request->get('firstname'));
        $user->setLastName($request->get('lastname'));
        $user->setBirthday(new \DateTime($request->get('birthday')));

        $interests = $request->get('interests');

        $repository1 = $this->getDoctrine()->getRepository('AppBundle:Interest');

        $removeHobbies = $user->getHobbies();
        foreach($removeHobbies as $removeHobby){
            $em->remove($removeHobby);
        }

        for($i = 0;$i<count($interests); $i++){
            $hobby = $repository1->findOneByHobby($interests[$i]);
            $userHobby = new Users_hobbies();
            $userHobby->setUser($user);
            $userHobby->setInterest($hobby);
            $userHobby->setUserId($user->getId());
            $userHobby->setHobbyId($hobby->getId());
            $em->persist($userHobby);
            $em->flush();
            $user->addHobby($userHobby);
            $em->persist($user);
        }

        $hobbies = $this->getHobbies($user);

        $em->flush();

        return $this->render('auth/user.html.twig', array(
            'user' => $user,
            'errors' => $errors,
            'user_interests' => $hobbies
        ));
    }

    /**
     * @Route("/registry", name="registry user")
     */

    public function registryAction(Request $request)
    {
        $user = new User();
        $user->setLogin($request->get('login'));
        $user->setPassword(($request->get('password')));

        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        $user->setPassword(($request->get('repeat')));


        $password = $request->get('password');
        $repeat = $request->get('repeat');

        $userError = null;
        if($repeat != $password){
            $userError = "Password should be the same as you repeat it";
        }
        
        if((count($errors) == 0) && ($request->get('submit') == 'Registry') && (empty($userError))){

            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($user);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();

            $hobbies = $this->getHobbies($user);

            //Отправим пользователя на форму с редактированием его данных
            return $this->render('auth/user.html.twig', array(
                'user' => $user,
                'errors' => $errors,
                'user_interests' => $hobbies
            ));
        } else {
            return $this->render('auth/registration.html.twig', array(
                'user' => $user,
                'errors' => $errors,
                'user_error' => $userError,
                'request' => $request
            ));
        }
    }

    public function getHobbies(User $user)
    {
        $reposInterests = $this->getDoctrine()->getRepository('AppBundle:Interest');

        $interests = $reposInterests->findAll();

        $userInterests = $user->getHobbies();

        //Получим те хобби, которые принадлежат именно пользователю
        foreach ($interests as $interest){
            $flag = 0;
            foreach ($userInterests as $userInterest){
                if($interest->getHobby() == $userInterest->getInterest()->getHobby())
                {
                    $hobbies[] = array('interest' => $interest->getHobby(), 'checked' => 'checked');
                    $flag = 1;
                    break;
                }
            }
            if ($flag == 0){
                $hobbies[] = array('interest' => $interest->getHobby(), 'checked' => '');
            }
        }

        return $hobbies;
    }
}