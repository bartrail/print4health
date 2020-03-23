import React from 'react';

class Index extends React.Component {
  render() {
    return (
      <div className="container startpage">
        <h2>print4health.org</h2>
        <div className="container-fluid">
          <div className="row">
            <div className="col">
            <h1>Motivation</h1>
            <p>In pandemischen Krisenzeiten gibt es im Gesundheitssektor einen großen Bedarf an Ersatzteilen. 
            Länder, in denen Krise schon weiter fortgeschritten ist, setzen bereits auf 3D-Druck als Lösung zur Bedarfsdeckung 
            im Gesundheitssektor. So unterstützen Maschinenbauer in Italien die Krankenhäuser mit 3D-gedruckten Ventilen, 
            die Beatmungsgeräte mit den Gesichtsmasken der Patienten verbinden. Die Polytechnische Universität Hong Kong 
            entwickelte Schutzschilder, um das medizinische Personal vor der Infizierung mit dem Coronavirus zu schützen. 
            Auch diese wurden in hoher Stückzahl mit 3D-Druckern gefertigt.
            Der Schutz vor neuen Infektionen mit dem Coronavirus Sars-CoV-2 veranlasst die Regierungen in aller Welt zu 
            drastischen Maßnahmen. Politische Entscheidungen beeinflussen viele Bürger::innen und der Eigen- und Fremdschutz hat
            höchste Priorität. Die zum Schutz vor Infektionen notwendigen Hilfsmittel sind allerdings in allen Ländern 
            Mangelware. Mit 3D gedruckten Produkten könnten viele kleine Beiträge zum Schutz vor Infektionen der Bevölkerung 
            geleistet werden. </p>
            <h1>Idee</h1>
            <p>Mit unserer Plattform zum Crowdproducing soll der Einsatz von 3D Druck zur Bekämpfung der Corana Pandemie effektiv, 
            schnell und solidarisch ermöglicht werden. Vom hochkomplexen Produkt, das individuell konstruiert werden muss, 
            bis zu open source Dateien für Masken, Türöffner und Wasserhahnadapter, die von jedem privaten 3D Drucker gefertigt werden können, 
            sollen Lösungen gefunden und angeboten werden. </p> 
            <h1>Wir brauchen jeden Einzelnen von Euch!</h1>
            <p>Die Plattform lebt von der stetigen Weiterentwicklung der Plattform und der Produkte. Das Know-How und die 
            Erfahrung der gesamten Community sind dabei gefragt: ob High-End Anwender mit großem Unternehmen im Hintergrund, 
            privater 3D Drucker, Medizintechniker oder Arzt - Euer Know How ist wertvoll und ist wichtig!</p>
            </div>
          </div>
          <div className="row mt-4"></div>
          <div className="row">
            <div className="col-sm">
            <div className="card shadow-sm">
            <div className="card-body">
              <h5 className="card-title">Bist du Krankenhaus?</h5>
              <p className="card-text">
              Du benötigst dringend Infektionsschutz oder Teile für Geräte?
              Dann schau auf unter Bedarf, ob Dein Produkt schon in der Datenbank ist. 
              Für dein gewünschtes Produkt existiert noch keine Druckvorlage? 
              Wende dich mit den Anforderungen an unsere Community und entwickle gemeinsam die Druckvorlage für deinen 
              konkreten Anwendungsfall.
              </p>
              </div>
              </div>
            </div>
            <div className="col-sm">
            <div className="card shadow-sm">
              <div className="card-body">
              <h5 className="card-title">Hast du Drucker?</h5>
              <p className="card-text">
               Dein Drucker steht noch still? Dann schau unter Bedarf, ob Du Deine Kapazität einsetzten kannst!
               Falls Du momentan keine Druckkapazität vorrhanden hast, leite den Bedarf gerne an Deine Druckcommunity weiter!
               Vielleicht kannst Du uns auch mit Deinem Know-How helfen! Sende uns gerne eine Email!               
              </p>
              </div>
              </div>
            </div>
            <div className="col-sm">
            <div className="card shadow-sm">
            <div className="card-body">
              <h5 className="card-title">Kannst du designen?</h5>
              <p className="card-text">
              Du bist Techniker, Ingenieur, Designer oder einfach nur kreativ? Dann wirst auch Du unbedingt gebraucht! 
              Deine Expertise im Bereich Medizintechnik und 3D Druck ist goldwert und kann in Zeiten der Corona Pandemie Leben retten!
              Nimm gerne Kontakt mit uns auf oder lade hilfreiche Dokumente in unserem upload Bereich hoch!
              </p>
              </div>
              </div>
            </div>
            <div className="col-sm">
            <div className="card shadow-sm">
            <div className="card-body">
              <h5 className="card-title">Bist du Medi?</h5>
              <p className="card-text">
              Du arbeitest in einer Arztpraxis, bist medizinisch technischer Assistent, in der Pflege, 
              Sani oder Student im Praktischen Jahr? Du brauchst Material zum Eigenschutz? Dann schaue unter Bedarf, 
              ob Dein Produkt schon in der Datenbank ist. Falls nicht nimm Kontaktmit uns auf!
              Oder willst Du Deine Erfahrungen aus der letzen Schicht oder Deine Expertise mit uns teilen? 
              Nimm gerne Kontakt mit uns auf! Auch Deine Erfahrung ist für die Gesellschaft so wichtig! 
              </p>
              </div>
              </div>
            </div>
          </div>
          </div>
      </div>
    );
  }
}

export default Index;
