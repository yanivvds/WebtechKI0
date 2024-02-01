import requests
from bs4 import BeautifulSoup
import time

#sources: https://www.youtube.com/watch?v=U90vK84bq4s and https://www.youtube.com/watch?v=XVv6mJpFOb0&t=395s


#haalt de stad/continent of locatie naam voor het compleet maken van de url.
def get_city_link() -> str:
    with open('locatie.txt','r') as f:
        stad = f.readline()
        #stad = input("Van welke stad wilt u de activiteiten zien? ")
        link = f'https://www.cntraveler.com/destinations/{stad}'
        return link

#Get request sturen nr server van gegeven url om het html bestand op te halen.
def get_html(url: str) -> requests.Response:
    try:
        response = requests.get(url, timeout=10) #geeft een 10 seconde timeout voordat de volgende request check gestuurd kan worden
        response.raise_for_status() #checkt of de get request al geslaagd is
        return response
    except requests.exceptions.RequestException as e: #geeft error melding als de webpagina niet gevonden kan worden of iets mis gaat bij de get request
        print(f"Error getting HTML data: {e}")
        return None

def get_artikel(raw_data: requests.Response) -> list:
    #creating arrays to store scraping data
    titel_array = []
    link_array = []
    foto_array = []

    #creating BeautifulSoup object used for searching html files
    bsObj = BeautifulSoup(raw_data.content, "html.parser")

    #scraping html files for the right classes and hmtl tags and putting it in a list
    titel_data = bsObj.find_all("div", class_="SummaryItemHedTag-TWblf gxaOcP summary-item__hed--fixed-margin-bottom")

    link1_data = bsObj.find_all("a", class_="SummaryItemHedLink-civMjp rgRxi summary-item-tracking__hed-link summary-item__hed-link")
    link2_data = bsObj.find_all("a", class_="SummaryItemHedLink-civMjp dgkWXq summary-item-tracking__hed-link summary-item__hed-link")

    foto_data = bsObj.find_all("img", class_="ResponsiveImageContainer-eybHBd fptoWY responsive-image__image")

    #storing the data from scraping in arrays and enhancing the data a bit.
    for n in titel_data:
        titel_array.append(n.text.strip())
    
    for n in link1_data:
        if n.get("href")[0] == '/':
            link_array.append(f'https://www.cntraveler.com{n.get("href")}')
        else:
            link_array.append(n.get("href"))

    for n in link2_data:
        if n.get("href")[0] == '/':
            link_array.append(f'https://www.cntraveler.com{n.get("href")}')
        else:
            link_array.append(n.get("href"))

    for n in foto_data:
        foto_array.append(n.get("src"))

    #writing scrapped data to a file so that java script can read data from there
    with open('artikel_data.txt', 'w') as f:
        #writing the data for as many artikel titels as we could find as we cant give any more links and images if there is no title found
        index_link = 0
        index_foto = 0
        for element in titel_array:
            f.write(element)
            f.write(link_array[index_link])
            f.write(foto_array[index_foto])
            index_link += 1
            index_foto += 1
    

def get_prijs(raw_data: requests.Response) -> list:
    prijs_array = []
    bsObj = BeautifulSoup(raw_data.content, "html.parser")
    prijs_data = bsObj.find_all("a", class_="SummaryItemHedLink-civMjp rgRxi summary-item-tracking__hed-link summary-item__hed-link")
    link_data = bsObj.find_all("a", class_="SummaryItemHedLink-civMjp dgkWXq summary-item-tracking__hed-link summary-item__hed-link")

    for n in prijs_data:
        prijs_array.append(n.get("href"))

    for n in link_data:
        if n.get("href")[0] == '/':
            prijs_array.append(f'https://www.cntraveler.com{n.get("href")}')
        else:
            prijs_array.append(n.get("href"))

    return prijs_array

def get_beoordeling(raw_data: requests.Response) -> list:
    beoordeling_array = []
    bsObj = BeautifulSoup(raw_data.content, "html.parser")
    foto_data = bsObj.find_all("img", class_="ResponsiveImageContainer-eybHBd fptoWY responsive-image__image")

    for n in beoordeling_data:
        beoordeling_array.append(n.get("src"))

    return beoordeling_array

city_link = get_city_link()
html_data = get_html(city_link)

if html_data:
    #activiteit_array = get_activiteit(html_data)
    #prijs_array = get_prijs(html_data)
    #beoordeling_array = get_beoordeling(html_data)
    get_artikel(html_data)

    print("Artikel titels:", titel_array)
    print(len(titel_array))
    print("Links:", link_array)
    print(len(link_array))
    print("fotos:", foto_array)