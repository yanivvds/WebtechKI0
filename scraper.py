import requests
from bs4 import BeautifulSoup
import time

#sources: https://www.youtube.com/watch?v=U90vK84bq4s and https://www.youtube.com/watch?v=XVv6mJpFOb0&t=395s

def get_city_link() -> str:
    stad = input("Van welke stad wilt u de activiteiten zien? ")
    link = f'https://www.cntraveler.com/destinations/{stad}'
    return link

def get_html(url: str) -> requests.Response:
    try:
        response = requests.get(url, timeout=10)
        response.raise_for_status()
        return response
    except requests.exceptions.RequestException as e:
        print(f"Error getting HTML data: {e}")
        return None

def get_activiteit(raw_data: requests.Response) -> list:
    name_array = []
    bsObj = BeautifulSoup(raw_data.content, "html.parser")
    name_data = bsObj.find_all("div", class_="SummaryItemHedTag-TWblf gxaOcP summary-item__hed--fixed-margin-bottom")

    for n in name_data:
        name_array.append(n.text.strip())

    return name_array

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
    beoordeling_data = bsObj.find_all("img", class_="ResponsiveImageContainer-eybHBd fptoWY responsive-image__image")

    for n in beoordeling_data:
        beoordeling_array.append(n.get("src"))

    return beoordeling_array

city_link = get_city_link()
html_data = get_html(city_link)

if html_data:
    activiteit_array = get_activiteit(html_data)
    prijs_array = get_prijs(html_data)
    beoordeling_array = get_beoordeling(html_data)

    print("Activiteiten:", activiteit_array)
    print(len(activiteit_array))
    print("Links:", prijs_array)
    print(len(prijs_array))
    print("Beoordelingen:", beoordeling_array)