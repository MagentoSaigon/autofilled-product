/**
 * Created by hp on 07/11/2016.
 */
function setSettings(urlTemplate, setElement)
{
    var productTemplateSyntax = /(^|.|\r|\n)({{(\w+)}})/;
    var template = new Template(urlTemplate, productTemplateSyntax);
    setLocation(template.evaluate({attribute_set:$F(setElement)}));
}
