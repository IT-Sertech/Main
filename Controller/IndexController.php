<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main\Controller;

use Core\Module\Controller;
use DI\DependencyException;
use DI\NotFoundException;
use Modules\Main\MainTrait;
use Slim\Http\ServerRequest as Request;
use Slim\Http\Response;

class IndexController extends Controller {

    use MainTrait;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    protected function registerFunctions(): void {
        $this->getMainRouter()->getMapBuilder($this);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function index(Request $request, Response $response): Response {
        $this->getView()->setVariables([
            'seo'=>[
                'title'=>'Startseite',
                'type'=>'article'
            ],
            'breadcrumbs'=>[
                'Home'=>'',
            ],
        ]);

        return $this->getView()->render($response, 'index');
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function page(Request $request, Response $response): Response {
        $page_name = $request->getAttribute("page");
        $page = $this->getMainManager()->getPageEntity()::where([
            ['name', '=', $page_name],
            ['lang', '=', $this->getMainModel()->getLang()],
            ['status', '=', 'publish']
        ])->first();

        if (is_null($page)){
            $response->withStatus(404);
            $this->getView()->setVariables([
                'seo'=>[
                    'title'=>'404 - Not Found',
                    'description'=>'Page Not Found',
                    'type'=>'article'
                ],
                'breadcrumbs'=>[
                    $this->getI18nModel()->translate('Home')=>['main_home'],
                    $this->getI18nModel()->translate('Page Not Found')=>''
                ],
            ]);
            return $this->getView()->render($response, 'error/404');
        }

        $breadcrumbs['Home'] = ['main_home'];
        $check = $this->getMainModel()->getParents($page->id);
        $breadcrumbs=array_merge($breadcrumbs, $check);
        $breadcrumbs[$page->title] = '';

        $page->content = $this->getView()->getHtmlFromContent($page->content);

        $template = "page/page";
        if ($page->landing === 1){
            $template .= "_landing";
        }

        $this->getView()->setVariables([
            'seo'=>[
                'title'=>$page->title,
                'description'=>$page->description,
                'image'=>$page->image,
                'type'=>'article',
                'published'=>$page->created_at,
                'modified'=>$page->updated_at,
            ],
            'breadcrumbs'=>$breadcrumbs,
            'page'=>$page,
        ]);
        return $this->getView()->render($response, $template);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function contact(Request $request, Response $response): Response {
        $formData = $request->getParsedBody();
        if (!empty($formData)){

            $url_regex = "([http|https]+:\/\/[a-z0-9.\/-]+)"; // SCHEME
            $email_regex = "[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})"; // EMAIL

            preg_match("/$url_regex/m", $formData['message'], $url_match);
            preg_match("/$email_regex/m", $formData['message'], $email_match);

            $recaptchaKey = $this->getConfig("security", "recaptchaKey");
            $recaptcha = false;
            if (!empty($formData['g-recaptcha-response'])){
                $captcha = $formData['g-recaptcha-response'];
                $resp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?
                secret=$recaptchaKey&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
                $recaptcha = json_decode($resp)->success;
            }
            else {
                $recaptcha = true;
            }

            if (!empty($url_match) || !empty($email_match) || $recaptcha === false){
                $data = [
                    'errorMessage'=>'Leider ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.',
                    'success' => false
                ];
                return $response->withJson($data, 200);
            }

            $mail = new \Swift_Message();
            $message = $this->getView()->getHtml('mail/contact', $formData);
            $mail->addReplyTo($formData['email'], $formData['name']);
            $mail->setSubject("Kontaktformular");
            $mail->setBody($message, "text/html");
            $this->setMessage('mail', $mail);

            $this->getView()->setVariables([
                'success'=>true,
                'successMessage' => 'Ihre Nachricht wurde erfolgreicht gesendet.'
            ]);
            return $this->getView()->renderJson($response);
        }
        else {
            $this->getView()->setVariables([
                'seo' => [
                    'title'=>'Kontakt',
                    'description'=>'Wir freuen uns auf Ihre Anfrage und stehen Ihnen für Informationen gerne zur Verfügung.'
                ],
                'breadcrumbs'=>[
                    'Home'=>['main_home'],
                    'Kontakt'=>''
                ],
            ]);
            return $this->getView()->render($response, 'page/contact');
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function sitemap (Request $request, Response $response): Response {
        $pages = $this->getMainManager()
            ->getPageEntity()::select("name", "updated_at")->where("status", "=", "publish")->get();
        $page_liste = '<url>
              <loc>https://www.example.de'.$this->getMainRouter()->getUrl("main_home").'</loc>
              <lastmod>'.date("Y-m-d\TH:i:sP", time()).'</lastmod>
              <changefreq>daily</changefreq>
              <priority>1</priority>
            </url>';
        foreach ($pages as $page){
            $page_liste.='<url>
              <loc>https://www.example.de'.$this->getMainRouter()->getUrl("main_page", ["page"=>$page->name]).'</loc>
              <lastmod>'.date("Y-m-d\TH:i:sP", strtotime($page->updated_at)).'</lastmod>
              <changefreq>daily</changefreq>
              <priority>0.9</priority>
            </url>';
        }

        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    $page_liste
</urlset>
XML;

        return $response->write($xml)
            ->withHeader('Content-Type', 'text/xml')
            ->withHeader('Content-Disposition', 'attachment;filename=sitemap.xml');
    }

}
