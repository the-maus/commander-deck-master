# Commander Deck Master

A web application for building and analyzing **Commander decks** from [Magic: The Gathering](https://magic.wizards.com/).

The app allows users to search cards, build decks, and analyze deck statistics such as **mana curve**, **color distribution**, and **land recommendations**.

Card data is retrieved from the [Scryfall API](https://scryfall.com/docs/api) and cached locally.

---

## Features

- 🔎 **Card Search** via Scryfall API  
- 🧱 **Commander Deck Builder** (100-card decks)  
- 📊 **Deck Analysis**
  - Mana curve
  - Color symbol distribution
  - Land recommendations
- 📚 **Interactive API Docs** using Swagger

---

### Scryfall Data Usage

This project uses card data and images from the **Scryfall API** for educational and portfolio purposes in accordance with the **Magic: The Gathering Fan Content Policy**.

Scryfall provides its card database free of charge for the purpose of building Magic-related tools, research projects, and community content.

This project follows the Scryfall data usage guidelines:

- The **Scryfall name and logos are not used in a way that implies endorsement** of this project.
- **Access to card data is not paywalled**. All card data used by the application remains freely accessible.
- The application **does not repackage or proxy Scryfall data**, but instead uses it to provide additional value through deck building and statistical analysis.
- Card data and images are **only used in the context of Magic: The Gathering**.

#### Card Image Guidelines

When displaying card images, this project follows Scryfall's image policies:

- Card images are **not cropped, altered, or distorted**.
- The **artist name and copyright information remain visible**.
- No **watermarks, overlays, or modifications** are applied to card images.
- Images are not used in a way that implies ownership by anyone other than **Wizards of the Coast**.

Improper use of Scryfall data may result in restricted API access, so this project adheres to their recommended usage practices.

For full details, see the official Scryfall documentation:

https://scryfall.com/docs/api