# NovaPAI PHP SDK Example 🐘

> Use NovaPAI in PHP — OpenAI-compatible API in 3 lines of code.

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![API](https://img.shields.io/badge/API-NovaPAI-6C47FF)](https://novapai.ai)
[![PHP](https://img.shields.io/badge/PHP-SDK-brightgreen)](#)

## What is NovaPAI?

[NovaPAI](https://novapai.ai) is an **OpenAI-compatible API gateway** that gives you access to top-tier LLMs like **DeepSeek V4 Pro** through the standard OpenAI SDK. If you know how to use the OpenAI API, you already know how to use NovaPAI — just change the `base_url`.

## Quick Start

### 1. Get an API Key

Sign up at [novapai.ai](https://novapai.ai) to get your free API key.

### 2. Install the SDK

```bash
composer require openai-php/client
```

### 3. Run the Example

```bash
# Clone this repo
git clone https://github.com/NovaStackAI/novapai-php.git
cd novapai-php

# Set your API key
export NOVAPAI_API_KEY="your-api-key"

# Run
php example.php
```

## Examples Included

| Example | Description |
|---------|------------|
| Basic Chat | Single-turn chat completion |
| Streaming | Real-time token-by-token streaming |
| Multi-turn Conversation | Context-aware multi-message dialogue |
| List Models | Fetch available model list |

## Core Concept

```python
# Standard OpenAI SDK — just change base_url!
from openai import OpenAI

client = OpenAI(
    api_key="your-novapai-key",
    base_url="https://api.novapai.ai/router/v1"  # ← Only this line changes!
)

response = client.chat.completions.create(
    model="deepseek-v4-pro",
    messages=[{"role": "user", "content": "Hello!"}]
)
print(response.choices[0].message.content)
```

**That's it.** The OpenAI SDK you already know works directly with NovaPAI. No new SDK to learn, no new API surface.

## Why NovaPAI?

- ✅ **OpenAI-Compatible** — Use any OpenAI SDK in any language
- ✅ **Top Models** — Access DeepSeek V4 Pro and more
- ✅ **One API Key** — All models, one account
- ✅ **No Vendor Lock-in** — Switch models with one line change

## Related Repos

Browse all our SDK examples:

- [novapai-python](https://github.com/NovaStackAI/novapai-python)
- [novapai-javascript](https://github.com/NovaStackAI/novapai-javascript)
- [novapai-typescript](https://github.com/NovaStackAI/novapai-typescript)
- [novapai-go](https://github.com/NovaStackAI/novapai-go)
- [novapai-rust](https://github.com/NovaStackAI/novapai-rust)
- [novapai-java](https://github.com/NovaStackAI/novapai-java)
- [novapai-csharp](https://github.com/NovaStackAI/novapai-csharp)
- [novapai-ruby](https://github.com/NovaStackAI/novapai-ruby)
- [novapai-curl](https://github.com/NovaStackAI/novapai-curl)

## Links

- 📖 [Official Website](https://novapai.ai)
- 🌐 [NovaStackAI GitHub](https://github.com/NovaStackAI)

---

Made with ❤️ by [NovaStackAI](https://github.com/NovaStackAI)
